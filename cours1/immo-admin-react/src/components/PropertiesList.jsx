import { Link} from "react-router-dom";
import { PropTypes } from "prop-types";
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;


export default function PropertiesList(props) {
  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }
  const { properties, messageChanger, propertiesChanger } = props;
  if (!properties["data"]) {
    return null;
  }

  const handleSell = (property) => {
    axios.put(apiUrl+"/property/"+property.id+'/sell')
    .then(function(response){
      const message = "Property "+response.data.name+ " has been sold"
      properties['data'] = properties['data'].filter((element) => element.id !== property.id)
      messageChanger(message)
      propertiesChanger(properties)

    }).catch(function(e){
      console.log(e)
    })
  }

  const handleUnSell = (property) => {
    axios.put(apiUrl+"/property/"+property.id+'/unsell')
    .then(function(response){
      const message = "Property "+response.data.name+ " has been unsold"
      properties['data'] = properties['data'].filter((element) => element.id !== property.id)
      messageChanger(message)
      propertiesChanger(properties)

    }).catch(function(e){
      console.log(e)
    })
  }

  const handleDelete = (property) => {
    axios.delete(apiUrl+"/property/"+property.id)
    .then(function(response){
      const message = "Property "+response.data.name+ " has been deleted"
      properties['data'] = properties['data'].filter((element) => element.id !== property.id)
      messageChanger(message)
      propertiesChanger(properties)

    }).catch(function(e){
      console.log(e)
    })
  }
  return (
    <>
      {properties["data"].map((property) => (
        <tr
          className="odd:bg-white  even:bg-gray-50 border-b hover:bg-gray-200"
          key={property.id}
        >
          <th
            scope="row"
            className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap "
          >
            {capitalize(property.name)}
          </th>
          <td className="px-6 py-4">{capitalize(property.type)}</td>
          <td className="px-6 py-4">{capitalize(property.city)}</td>
          <td className="px-6 py-4">{property.rooms}</td>
          <td className="px-6 py-4">{property.bedrooms}</td>
          <td className="px-6 py-4">${property.price}</td>
          <td className="px-6 py-4 text-right">
            {!property.is_sold && (
              <>
                <Link to={property.id.toString()}>
                  <button
                    type="button"
                    className="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                  >
                    Edit
                  </button>
                </Link>
                <button
                  type="button"
                  onClick={() => handleSell(property)}
                  className="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 me-2"
                >
                  Sell
                </button>
              </>
            )}
            {property.is_sold && (
              <>
                <button
                  type="button"
                  onClick={() => handleUnSell(property)}
                  className="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 me-2"
                >
                  Unsell
                </button>
              </>
            )}
            <button
              type="button"
              onClick={() => handleDelete(property)}
              className="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 "
            >
              Delete
            </button>
          </td>
        </tr>
      ))}
    </>
  );
}

PropertiesList.propTypes = {
  properties: PropTypes.any,
  propertiesChanger: PropTypes.any,
  messageChanger: PropTypes.any,
};
