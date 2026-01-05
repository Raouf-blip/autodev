<?php

namespace App\Controllers;

use App\Models\Option;
use App\Utils\JsonWriter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class OptionController extends AppController
{
    public function __construct(private ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function create(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            $option = new Option();
            $option->name = $data['name'];
            $option->save();

            return JsonWriter::success($response, Status::HTTP_OK, $option);
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function list(Request $request, Response $response, array $args): Response
    {
        try {
            $options = Option::all();

            return JsonWriter::success($response, Status::HTTP_OK, $options);
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        try {
            $option = Option::findOrFail($args['id']);

            return JsonWriter::success($response, Status::HTTP_OK, $option);
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
            $option = Option::findOrFail($args['id']);
            $option->name = $data['name'];
            $option->save();

            return JsonWriter::success($response, Status::HTTP_OK, $option);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        try {
            $option = Option::findOrFail($args['id']);
            $option->delete();

            return JsonWriter::success($response, Status::HTTP_OK, $option);
        } catch(ModelNotFoundException $e) {
            return JsonWriter::error($response, Status::HTTP_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return JsonWriter::error($response, Status::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
