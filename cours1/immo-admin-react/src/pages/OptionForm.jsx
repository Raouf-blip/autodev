import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
const apiUrl = import.meta.env.VITE_API_URL;

export default function OptionForm() {
  const navigate = useNavigate();
  const { id } = useParams();
  const [option, setOption] = useState({});
  const [error, setError] = useState();

  useEffect(() => {
    if (id) {
      fetch(apiUrl+"/option/" + id)
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          setOption(data);
        });
    }
  }, [id]);

  const onHandleChange = (e) => {
    const { name, value } = e.target;
    setOption((pre) => ({
      ...pre,
      [name]: value,
    }));
  };

  const onHandleSave = (e) => {
    e.preventDefault()
    const data = option;
    const url = apiUrl+"/option/" + (id ?? "");
    axios
      .post(url, JSON.stringify(data), {
        headers: {
          "Content-Type": "application/json",
        },
      })
      .then(function (response) {
        console.log(response);
        const message =
          "option " + response.data.name + (id ? " updated" : " created");
        navigate("/options", { state: { message } });
      })
      .catch(function (error) {
        setError(error);
      });
  };

  return (
    <section className="bg-white">
      <div className="px-4 mx-auto max-w-screen-xl lg:py-16 ">
        <h1 className="mb-6 text-xl font-extrabold tracking-tight leading-none text-blue-600 md:text-2xl lg:text-3x">
          {id ? "Edit Option " : "New Option"}
        </h1>
        {error && (
          <div
            id="alert-2"
            className="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 border-2 border-red-500"
            role="alert"
          >
            <svg
              className="flex-shrink-0 w-4 h-4"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span className="sr-only">Info</span>
            <div className="ms-3 text-sm font-medium">
              {error.response.data.message ?? error.toString()}
            </div>
            <button
              type="button"
              onClick={() => setError(null)}
              className="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
              aria-label="Close"
            >
              <span className="sr-only">Close</span>
              <svg
                className="w-3 h-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
              >
                <path
                  stroke="currentColor"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                />
              </svg>
            </button>
          </div>
        )}
        <form onSubmit={(e) => onHandleSave(e)}>
          <div className="mb-6">
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
              value={option.name ?? ""}
              onChange={(e) => onHandleChange(e)}
              className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Name"
            />
          </div>
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
    </section>
  );
}
