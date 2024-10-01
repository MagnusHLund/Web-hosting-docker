import { FaEllipsisV } from "react-icons/fa";
import "./Table.scss";

interface TableProps {
  handleOpenModal: () => void;
}

const Table: React.FC<TableProps> = ({ handleOpenModal }) => {
  return (
    <div className="table-container">
      <table className="table">
        <thead className="table__header">
          <tr className="table__header-row">
            <th className="table__header-cell">Name</th>
            <th className="table__header-cell">Email</th>
            <th className="table__header-cell">Role</th>
            <th className="table__header-cell">Status</th>
            <th className="table__header-cell">Actions</th>
          </tr>
        </thead>
        <tbody className="table__body">
          <tr className="table__body-row">
            <td className="table__body-cell">John Doe</td>
            <td className="table__body-cell">john.doe@example.com</td>
            <td className="table__body-cell">Admin</td>
            <td className="table__body-cell">Active</td>
            <td className="table__body-cell">
              <FaEllipsisV
                className="table__action-icon"
                onClick={handleOpenModal}
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  );
};

export default Table;
