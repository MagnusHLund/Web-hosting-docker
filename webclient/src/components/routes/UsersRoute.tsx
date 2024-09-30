import { FaEllipsisV } from "react-icons/fa"; // Import the vertical dots icon
import SearchBar from "../input/SearchBar"; // Adjust the import path as needed
import Button from "../input/Button"; // Adjust the import path as needed
import "./UsersRoute.scss";
import { useState } from "react";
import Modal from "../content/Modal";

const UsersRoute: React.FC = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleOpenModal = () => setIsModalOpen(true);
  const handleCloseModal = () => setIsModalOpen(false);

  return (
    <div className="users-route-container">
      <div className="users-route-header">
        <h2 className="users-route-title">Users</h2>
        <div className="header-actions">
          <SearchBar />
          <Button
            text="Add User"
            onClick={() => console.log("Add user clicked!")}
          />
        </div>
      </div>
      <div className="users-table-container">
        <table className="users-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>John Doe</td>
              <td>john.doe@example.com</td>
              <td>Admin</td>
              <td>Active</td>
              <td>
                <FaEllipsisV
                  className="action-icon"
                  onClick={handleOpenModal}
                />
              </td>{" "}
            </tr>
          </tbody>
        </table>
      </div>

      {isModalOpen && (
        <Modal showTitle={false} onClose={handleCloseModal}>
          <div>
            <Button text="Git Pull" onClick={() => console.log("Git Pull")} />
            <Button text="Edit" onClick={() => console.log("Edit")} />
            <Button text="Disable" onClick={() => console.log("Disable")} />
            <Button text="Delete" onClick={() => console.log("Delete")} />
          </div>
        </Modal>
      )}
    </div>
  );
};

export default UsersRoute;
