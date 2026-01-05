import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import Select from 'react-tailwindcss-select'
import axios from 'axios';
import { v4 as uuidv4 } from 'uuid';
const apiUrl = import.meta.env.VITE_API_URL;

export default function PropertyForm() {
  const navigate = useNavigate();
  const { id } = useParams();
  const [property, setProperty] = useState({});
  const [error, setError] = useState();
  const [options, setOptions] = useState([]);
  const [optionsSelected, setOptionsSelected] = useState(null)

  useEffect(() => {
    fetch(apiUrl + "/option")
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        setOptions(transformArrayOptions(data))
      });
    if (id) {
      fetch(apiUrl + "/property/" + id)
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          setProperty(data);
          setOptionsSelected(transformArrayOptions(data.options))
        });
    }
  }, [id]);

  function transformArrayOptions(arr) {
    return arr.map(item => ({
      value: item.id.toString(),
      label: item.name,
      disabled: false
    }));
  }

  function getBase64FromFileList(fileList) {
    const filePromises = Array.from(fileList).map(file => {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve({ id: uuidv4(), link: reader.result, type: "new" });
        reader.onerror = error => reject(error);
        reader.readAsDataURL(file);
      });
    });

    return Promise.all(filePromises);
  }

  const onHandleChange = (e) => {
    const { name, value } = e.target;
    setProperty(pre => ({
      ...pre,
      [name]: value
    }))
  }

  const onHandleDeleteImage = (image) => {
    setProperty(pre => ({
      ...pre,
      "images": pre.images.map(item => {
        if (item.id === image) {
          return { ...item, 'type': 'delete' };
        }
        return item;
      })
    }))
  }

  const onHandleAddImage = (e) => {
    if (e.target.files) {
      getBase64FromFileList(e.target.files)
        .then(base64Array => {
          e.target.value = null
          setProperty(pre => ({
            ...pre,
            "images": pre.images ? pre.images.concat(base64Array) : base64Array
          }))
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
  const onHandleSave = (e) => {
    e.preventDefault()
    const data = property
    data.options = optionsSelected?.map((option) => parseInt(option.value))
    const url = apiUrl+'/property/' + (id ?? "")
    axios.post(url, JSON.stringify(data), {
      headers: {
        'Content-Type': 'application/json',
      }
    }).then(function (response) {
      const message = "Property " + response.data.name + (id ? ' updated' : ' created')
      navigate('/properties', { state: { message } })
    }).catch(function (error) {
      setError(error)
    })

  }
  return (
    <section className="bg-white">
      <div className="px-4 mx-auto max-w-screen-xl lg:py-16 ">
        <h1 className="mb-6 text-xl font-extrabold tracking-tight leading-none text-blue-600 md:text-2xl lg:text-3x">
          {id ? "Edit Property " : "New Property"}
        </h1>
        {error &&
          <div id="alert-2" className="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border-2 border-red-500" role="alert">
            <svg className="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span className="sr-only">Info</span>
            <div className="ms-3 text-sm font-medium">
              {error.response.data.message ?? error.toString()}
            </div>
            <button type="button" onClick={() => setError(null)} className="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
              <span className="sr-only">Close</span>
              <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
            </button>
          </div>
        }
        <div className="mb-6">
          <form onSubmit={(e) => onHandleSave(e)}>
            <div className="grid gap-6 mb-6 md:grid-cols-3">
              <div>
                <label
                  htmlFor="name"
                  className="block mb-2 text-sm font-medium text-gray-900"
                >
                  Name
                </label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  value={property.name ?? ""}
                  onChange={(e) => onHandleChange(e)}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Name"
                />
              </div>
              <div>
                <label htmlFor="type" className="block mb-2 text-sm font-medium text-gray-90">Select a type</label>
                <select onChange={(e) => onHandleChange(e)} id="type" value={property.type ?? ""} name="type" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                  <option value="">Choose a type</option>
                  <option value="house">House</option>
                  <option value="apartment">Apartment</option>
                  <option value="commercial">Commercial</option>
                </select>

              </div>
              <div>
                <label
                  htmlFor="city"
                  className="block mb-2 text-sm font-medium text-gray-900"
                >
                  City
                </label>
                <input
                  type="text"
                  id="city"
                  name="city"
                  value={property.city ?? ""}
                  onChange={(e) => onHandleChange(e)}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="City"
                />
              </div>
            </div>
            <div className="grid gap-6 mb-6 md:grid-cols-2">
              <div>
                <label
                  htmlFor="price"
                  className="block mb-2 text-sm font-medium text-gray-900"
                >
                  Price
                </label>
                <input
                  type="number"
                  id="price"
                  name="price"
                  onChange={(e) => onHandleChange(e)}
                  value={property.price ?? ""}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Price"
                />
              </div>
              <div>
                <label
                  htmlFor="Surface"
                  className="block mb-2 text-sm font-medium text-gray-900"
                >
                  Surface
                </label>
                <input
                  type="number"
                  id="surface"
                  name="surface"
                  onChange={(e) => onHandleChange(e)}
                  value={property.surface ?? ""}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Surface"
                />
              </div>
            </div>
            <div className='mb-6'>
              <label htmlFor="description" className="block mb-2 text-sm font-medium text-gray-900">Description</label>
              <textarea id="description" name="description" onChange={(e) => onHandleChange(e)} rows="4" className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Description..." value={property.description ?? ""} />
            </div>
            <div className="mb-6">
              <label
                htmlFor="options"
                className="block mb-2 text-sm font-medium text-gray-900"
              >
                Options
              </label>
              <Select
                id="options"
                primaryColor={'blue'}
                options={options}
                value={optionsSelected}
                onChange={value => setOptionsSelected(value)}
                isMultiple={true}
              />
            </div>
            <div className="mb-6">
              <label
                htmlFor="options"
                className="block mb-2 text-sm font-medium text-gray-900"
              >
                Images
              </label>
              <div className="flex items-center justify-center w-full">
                <label htmlFor="images" className="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                  <div className="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg className="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                      <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                    </svg>
                    <p className="mb-2 text-sm text-gray-500"><span className="font-semibold">Click to upload</span> or drag and drop</p>
                  </div>
                  <input id="images" name="images" onChange={onHandleAddImage} type="file" className="hidden" multiple />
                </label>
              </div>

            </div>
            {property?.images &&
              <div className="grid gap-6 md:grid-cols-3 mb-6">
                {property.images.map((item) => (
                  item.type !== 'delete' && (
                    <div className="relative" key={item.id}>
                      <img className="w-full  rounded-lg" src={item.link} alt={"Image " + item.id} />
                      <button type="button" onClick={() => onHandleDeleteImage(item.id)} className="absolute top-2 right-2 ms-auto  bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
                        <span className="sr-only">Close</span>
                        <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                      </button>
                    </div>

                  )
                ))}
              </div>
            }
            <div className="text-right mb-6">
              <button
                type="button"
                onClick={(e) => onHandleSave(e)}
                className="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  );
}