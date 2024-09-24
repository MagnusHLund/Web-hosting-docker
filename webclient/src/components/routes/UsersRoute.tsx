import { FaEllipsisV } from "react-icons/fa"; // Import the vertical dots icon
import SearchBar from "../input/SearchBar"; // Adjust the import path as needed
import Button from "../input/Button"; // Adjust the import path as needed
import "./UsersRoute.scss";

const UsersRoute: React.FC = () => {
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
              <th>Actions</th> {/* Added Actions column */}
            </tr>
          </thead>
          <tbody>
            {/* Example data rows */}
            <tr>
              <td>John Doe</td>
              <td>john.doe@example.com</td>
              <td>Admin</td>
              <td>Active</td>
              <td>
                <FaEllipsisV className="action-icon" />
              </td>{" "}
              {/* Vertical dots icon */}
            </tr>
            <tr>
              <td>Jane Smith</td>
              <td>jane.smith@example.com</td>
              <td>User</td>
              <td>Inactive</td>
              <td>
                <FaEllipsisV className="action-icon" />
              </td>
            </tr>
            <tr>
              <td>Bob Johnson</td>
              <td>bob.johnson@example.com</td>
              <td>Moderator</td>
              <td>Active</td>
              <td>
                <FaEllipsisV className="action-icon" />
              </td>
            </tr>
            <tr>
              <td>Alice Brown</td>
              <td>alice.brown@example.com</td>
              <td>User</td>
              <td>Active</td>
              <td>
                <FaEllipsisV className="action-icon" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  );
};

export default UsersRoute;
