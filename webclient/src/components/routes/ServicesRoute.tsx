import Table from "../content/Table";
import User from "../content/User";
import Button from "../input/Button";
import SearchBar from "../input/SearchBar";
import "./ServicesRoute.scss";

function ServicesRoute() {
  const dummyData = [
    {
      id: 1,
      user: "#",
      name: "",
      port: 3030,
      type: "",
      status: "",
    },
    {
      id: 2,
      user: "#",
      name: "",
      port: 3030,
      type: "",
      status: "",
    },
    {
      id: 3,
      user: "#",
      name: "",
      port: 3030,
      type: "",
      status: "",
    },
    {
      id: 4,
      user: "#",
      name: "",
      port: 3030,
      type: "",
      status: "",
    },
    {
      id: 5,
      user: "#",
      name: "",
      port: 3030,
      type: "",
      status: "",
    },
  ];
  const headers = ["Name", "Email", "Role", "Status"];
  const rows = dummyData.map((user) => <User key={user.id} user={user} />);

  return (
    <div className="services-route-container">
      <div className="services-route-header">
        <h2 className="services-route-title">Services</h2>
        <div className="services-route-header__actions">
          <SearchBar />
          <Button text="Add service" />
        </div>
      </div>

      <Table headers={headers} rows={rows} />
    </div>
  );
}

export default ServicesRoute;
