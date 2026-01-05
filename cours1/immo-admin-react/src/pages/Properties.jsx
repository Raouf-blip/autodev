import { useEffect, useState } from "react";
import Pagination from "react-js-pagination";
import { Link, useLocation } from "react-router-dom";
import PropertiesList from "../components/PropertiesList";
const apiUrl = import.meta.env.VITE_API_URL;

export default function Properties() {

  const location = useLocation();
  const [properties, setProperties] = useState([]);
  const [page, setPage] = useState(1);
  const [search, setSearch] = useState("");
  const [sold, setSold] = useState(false);
  const [priceGt, setPriceGt] = useState("");
  const [priceLt, setPriceLt] = useState("");
  const [message, setMessage] = useState(location?.state?.message);
  const types = ['House', 'Apartment', 'Commercial']
  const [checkedType, setCheckedType] = useState(
    new Array(types.length).fill(false)
  );
  const handleOnChange = (position) => {
    const updatedCheckedState = checkedType.map((item, index) =>
      index === position ? !item : item
    );
    setCheckedType(updatedCheckedState);
  }
  useEffect(() => {
    const filterType = types.filter((value, index) => checkedType[index])
    fetch(
      apiUrl + "/property?" +
      "limit=10" +
      "&page=" +
      page +
      "&name=" +
      search +
      "&price_gt=" +
      priceGt +
      "&price_lt=" +
      priceLt +
      "&types=" +
      filterType +
      "&sold=" +
      sold
    )
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        setProperties(data);
      });
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [page, priceGt, priceLt, search, checkedType, sold]);

  return (
    <>
      <section className="bg-white">
        <div className="px-4 mx-auto max-w-screen-xl lg:py-16">

          <h1 className="mb-6 text-xl font-extrabold tracking-tight leading-none text-blue-600 md:text-2xl lg:text-3x">
            Properties
          </h1>
          {message &&
            <div id="alert-2" className="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 border-2 border-blue-500" role="alert">
              <svg className="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
              </svg>
              <span className="sr-only">Info</span>
              <div className="ms-3 text-sm font-medium">
                {message}
              </div>
              <button type="button" onClick={() => setMessage(null)} className="ms-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8" aria-label="Close">
                <span className="sr-only">Close</span>
                <svg className="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
              </button>
            </div>
          }

          <div className="flex justify-between">
            <div>
              <label className="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_sold" onChange={() => setSold(!sold)} className="sr-only peer" checked={sold} />
                <div className="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                <span className="ms-3 text-sm font-medium text-gray-90">Sold</span>
              </label>
            </div>
            <Link to="new">
              <button
                type="button"
                className="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2"
              >
                New Property
              </button>
            </Link>
          </div>
          <div className="mb-6">
            <form>
              <div className="mb-6">
                <label
                  htmlFor="search"
                  className="block mb-2 text-sm font-medium text-gray-900"
                >
                  Search by name
                </label>
                <input
                  name="search"
                  id="search"
                  type="text"
                  value={search}
                  onChange={(e) => setSearch(e.target.value)}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  placeholder="Name"
                />
              </div>
              <div className="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                  <label
                    htmlFor="price_gt"
                    className="block mb-2 text-sm font-medium text-gray-900"
                  >
                    Min Price
                  </label>
                  <input
                    type="number"
                    id="price_gt"
                    value={priceGt}
                    onChange={(e) => setPriceGt(e.target.value)}
                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Min"
                  />
                </div>
                <div>
                  <label
                    htmlFor="price_gt"
                    className="block mb-2 text-sm font-medium text-gray-900"
                  >
                    Max Price
                  </label>
                  <input
                    type="number"
                    id="price_lt"
                    value={priceLt}
                    onChange={(e) => setPriceLt(e.target.value)}
                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Max"
                  />
                </div>
              </div>
              <div className="flex items-center justify-evenly mb-6">
                {types.map((type, index) => (
                  <div className="flex items-center h-5" key={type}>
                    <input
                      id={type}
                      type="checkbox"
                      value={type}
                      name={type}
                      checked={checkedType[index]}
                      onChange={() => handleOnChange(index)}
                      className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300"
                    />
                    <label
                      htmlFor={type}
                      className="ms-2 text-sm font-medium text-gray-90"
                    >
                      {type}
                    </label>
                  </div>
                ))}
              </div>
            </form>
          </div>

          <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left rtl:text-right text-gray-500 ">
              <thead className="text-xs text-gray-700 uppercase bg-gray-50  ">
                <tr>
                  <th scope="col" className="px-6 py-3">
                    Name
                  </th>
                  <th scope="col" className="px-6 py-3">
                    Type
                  </th>
                  <th scope="col" className="px-6 py-3">
                    City
                  </th>
                  <th scope="col" className="px-6 py-3">
                    Rooms
                  </th>
                  <th scope="col" className="px-6 py-3">
                    Bedrooms
                  </th>
                  <th scope="col" className="px-6 py-3">
                    Price
                  </th>
                  <th scope="col" className="px-6 py-3">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                <PropertiesList properties={properties} messageChanger={setMessage} propertiesChanger={setProperties} />
              </tbody>
            </table>
          </div>
          <div className="text-right">
            <Pagination
              totalItemsCount={parseInt(properties.total)}
              activePage={properties.current_page}
              itemsCountPerPage={properties.per_page}
              pageRangeDisplayed={5}
              onChange={(page) => setPage(page)}
              innerClass="inline-flex -space-x-px text-base h-10 mt-4 "
              itemClassFirst="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700"
              itemClassLast="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700"
              itemClass="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700"
              activeClass="flex items-center justify-center px-4 h-10 bg-blue-100 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700"
              firstPageText="First"
              lastPageText="Last"
              prevPageText="<"
              nextPageText=">"
            />
          </div>
        </div>
      </section>
    </>
  );
}


