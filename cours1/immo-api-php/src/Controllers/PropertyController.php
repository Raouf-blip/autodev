<?php

namespace App\Controllers;

use App\Models\Property;
use App\Utils\JsonWriter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PropertyController extends AppController
{
    public function __construct(private ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            $property = new Property();
            $property->name = $data['name'];
            $property->type = $data['type'];
            $property->description = $data['description'];
            $property->city = $data['city'];
            $property->surface = $data['surface'];
            $property->price = $data['price'];
            $property->is_sold = 0;
            $property->save();
            $property->options()->sync($data['options'] ?? null);
            $property->load('options');
            try{
                if (isset($data['images'])) {
                    foreach ($data['images'] as $image) {
                        $this->container->get('s3')->saveImage($image['link'], $image['id'], $property->id);
                    }
                }
            }catch(\Exception $e) {
            }

            return JsonWriter::success($response, Status::HTTP_OK, $property);
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        try {
            $params = $request->getQueryParams();
            $limit = $params['limit'];
            $page = $params['page'];
            $order = $params['order'];
            $url = $request->getUri()->getPath();
            $properties = Property::query();
            if (! empty($params['name'])) {
                $properties->where('name', 'like', '%'.$params['name'].'%');
            }
            if (! empty($params['types'])) {
                $properties->whereIn('type', explode(",", $params['types']));
            }
            if (! empty($params['price_gt'])) {
                $properties->where('price', '>', $params['price_gt']);
            }
            if (! empty($params['price_lt'])) {
                $properties->where('price', '<', $params['price_lt']);
            }
            if (! empty($params['sold'])) {
                $properties->where('is_sold', $params['sold'] === "true" ? 1 : 0);
            }
            $properties = $properties->without('options')->orderBy('id', $order)->paginate(perPage: $limit, page: $page)->setPath($url)->appends($request->getQueryParams());

            try {
                array_map(fn ($property) =>
                  $property->images = $this->container->get('s3')->getImages($property->id), $properties->items());
            } catch (\Exception $e) {
            }

            return JsonWriter::success($response, Status::HTTP_OK, $properties);
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        try {
            $property = Property::findOrFail($args['id']);

            try {
                $property->images = $this->container->get('s3')->getImages($property->id);
            } catch(\Exception $e) {
            }
            $property->load('options');

            return JsonWriter::success($response, Status::HTTP_OK, $property);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function sell(Request $request, Response $response, array $args): Response
    {
        try {
            $property = Property::findOrFail($args['id']);
            $property->is_sold = 1;
            $property->save();

            return JsonWriter::success($response, Status::HTTP_OK, $property);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function unsell(Request $request, Response $response, array $args): Response
    {
        try {
            $property = Property::findOrFail($args['id']);
            $property->is_sold = 0;
            $property->save();

            return JsonWriter::success($response, Status::HTTP_OK, $property);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            $property = Property::findOrFail($args['id']);
            $property->name = $data['name'];
            $property->type = $data['type'];
            $property->description = $data['description'];
            $property->city = $data['city'];
            $property->surface = $data['surface'];
            $property->price = $data['price'];
            $property->is_sold = $data['is_sold'];
            $property->save();
            $property->options()->sync($data['options'] ?? null);
            $property->load('options');
            if (isset($data['images'])) {
                try {
                    foreach ($data['images'] as $image) {
                        if (! isset($image['type'])) {
                            continue;
                        } elseif ($image['type'] === 'delete') {
                            $this->container->get('s3')->deleteImage($image['id'], $property->id);
                        } elseif ($image['type'] === 'new') {
                            $this->container->get('s3')->saveImage($image['link'], $image['id'], $property->id);
                        }
                    }
                } catch(\Exception $e) {
                }
            }

            return JsonWriter::success($response, Status::HTTP_OK, $property);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        try {
            $property = Property::findOrFail($args['id']);
            $property->delete();

            return JsonWriter::success($response, Status::HTTP_OK, $property);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function addImage(Request $request, Response $response, array $args): Response
    {
        try {
            $image = $request->getParsedBody()['image'];

            try {
                $uuid = uniqid();
                $s3 = $this->container->get('s3');
                $s3->putObject([
                  'Bucket' => getenv('S3_BUCKET'),
                  'Key' => $args['id'].'/'.$uuid,
                  'Body' => base64_decode($image),
                  'ContentEncoding' => 'base64',
                  'ContentType' => 'image/jpeg',
                ]);
            } catch (\Throwable $e) {
                return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
            }

            return JsonWriter::success($response, Status::HTTP_OK, ['message' => 'successfully uploaded']);
        } catch(\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function deleteImage(Request $request, Response $response, array $args): Response
    {
        try {
            $image = $args['image_id'];
            $property = Property::findOrFail($args['id']);

            $s3 = $this->container->get('s3');
            $s3->deleteImage($property->id, $image);

            return JsonWriter::success($response, Status::HTTP_OK, ['message' => 'successfully deleted']);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
