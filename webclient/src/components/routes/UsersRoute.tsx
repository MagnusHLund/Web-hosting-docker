import SearchBar from "../input/SearchBar";
import Button from "../input/Button";
import "./UsersRoute.scss";
import { useState } from "react";
import Modal from "../content/Modal";
import Table from "../content/Table"; // Import the new Table component

const UsersRoute: React.FC = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleOpenModal = () => setIsModalOpen(true);
  const handleCloseModal = () => setIsModalOpen(false);

  return (
    <div className="users-route-container">
      <div className="users-route-header">
        <h2 className="users-route-title">Users</h2>
        <div className="users-route-header__actions">
          <SearchBar />
          <Button
            text="Add User"
            onClick={() => console.log("Add user clicked!")}
          />
        </div>
      </div>

      <Table handleOpenModal={handleOpenModal} />

      {isModalOpen && (
        <Modal showTitle={false} onClose={handleCloseModal}>
          <div style={{width: "200px"}}>
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
