import { Link} from "react-router-dom";
import { PropTypes } from "prop-types";
import axios from 'axios';
const apiUrl = import.meta.env.VITE_API_URL;


export default function OptionsList(props) {
  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }
  const { options, messageChanger, optionsChanger } = props;
  const handleDelete = (option) => {
    axios.delete(apiUrl+"/option/"+option.id)
    .then(function(response){
      const message = "Option "+response.data.name+ " has been deleted"
      messageChanger(message)
      optionsChanger(options.filter((element) => element.id !== option.id))

    }).catch(function(e){
      console.log(e)
    })
  }
  return (
    <>
      {options.map((option) => (
        <tr
          className="odd:bg-white  even:bg-gray-50 border-b hover:bg-gray-200"
          key={option.id}
        >
          <th
            scope="row"
            className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap "
          >
            {capitalize(option.name)}
          </th>
          <td className="px-6 py-4 text-right">
                <Link to={option.id.toString()}>
                  <button
                    type="button"
                    className="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                  >
                    Edit
                  </button>
                </Link>
            <button
              type="button"
              onClick={() => handleDelete(option)}
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

OptionsList.propTypes = {
  options: PropTypes.any,
  optionsChanger: PropTypes.any,
  messageChanger: PropTypes.any,
};
