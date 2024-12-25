import Table from "../content/Table";
import User from "../content/User";

const dummyUsers = [
  {
    id: 1,
    name: "Alice Smith",
    email: "alice@example.com",
    role: "Admin",
    status: "Active",
  },
  {
    id: 2,
    name: "Bob Johnson",
    email: "bob@example.com",
    role: "User",
    status: "Inactive",
  },
  {
    id: 3,
    name: "Charlie Brown",
    email: "charlie@example.com",
    role: "User",
    status: "Active",
  },
  {
    id: 4,
    name: "Diana Prince",
    email: "diana@example.com",
    role: "Admin",
    status: "Active",
  },
  {
    id: 5,
    name: "Ethan Hunt",
    email: "ethan@example.com",
    role: "User",
    status: "Inactive",
  },
];

const UsersRoute = () => {
  const headers = ["Name", "Email", "Role", "Status"];
  const rows = dummyUsers.map((user) => <User key={user.id} user={user} />);

  return <Table headers={headers} rows={rows} />;
};

export default UsersRoute;
