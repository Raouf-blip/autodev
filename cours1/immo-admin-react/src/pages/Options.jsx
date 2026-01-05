import { useEffect, useState } from "react";
import { Link, useLocation } from "react-router-dom";
import OptionsList from "../components/OptionsList";
const apiUrl = import.meta.env.VITE_API_URL;

export default function Options() {
  const location = useLocation();
  const [options, setOptions] = useState([]);
  const [message, setMessage] = useState(location?.state?.message);

  useEffect(() => {
    fetch(apiUrl + "/option")
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        setOptions(data);
      });
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  return (
    <>
      <section className="bg-white">
        <div className="px-4 mx-auto max-w-screen-xl lg:py-16">
          <h1 className="mb-6 text-xl font-extrabold tracking-tight leading-none text-blue-600 md:text-2xl lg:text-3x">
            Options
          </h1>
          {message && (
            <div
              id="alert-2"
              className="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 border-2 border-blue-500"
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
              <div className="ms-3 text-sm font-medium">{message}</div>
              <button
                type="button"
                onClick={() => setMessage(null)}
                className="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8"
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
          <div className="flex justify-end">
            <Link to="new">
              <button
                type="button"
                className="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2"
              >
                New Option
              </button>
            </Link>
          </div>

          <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 ">
              <thead className="text-xs text-gray-700 uppercase bg-gray-50  ">
                <tr>
                  <th scope="col" className="px-6 py-3">
                    Name
                  </th>
                  <th scope="col" className="px-6 py-3">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <OptionsList
                  options={options}
                  messageChanger={setMessage}
                  optionsChanger={setOptions}
                />
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </>
  );
}
