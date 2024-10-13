import Table from "../content/Table";
import Button from "../input/Button";
import SearchBar from "../input/SearchBar";
import "./ServicesRoute.scss";

function ServicesRoute() {
  // Example users data
  const users = [
    {
      id: 1,
      name: "John Doe",
      email: "john.doe@example.com",
      role: "Admin",
      status: "Active",
    },
    {
      id: 2,
      name: "Jane Smith",
      email: "jane.smith@example.com",
      role: "Editor",
      status: "Inactive",
    },
    {
      id: 2,
      name: "Jane Smith",
      email: "jane.smith@example.com",
      role: "Editor",
      status: "Inactive",
    },
  ];

  return (
    <div className="Services-route-container">
      <div className="Services-route-header">
        <h2 className="Services-route-title">Services</h2>
        <div className="Services-route-header__actions">
          <SearchBar />
          <Button text="Add service" />
        </div>
      </div>
      <Table users={users} />
    </div>
  );
}

export default ServicesRoute;
