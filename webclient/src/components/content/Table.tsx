import "./Table.scss";
import User from "./User";

interface TableProps {
  users: Array<{
    id: number;
    name: string;
    email: string;
    role: string;
    status: string;
  }>;
}

const Table: React.FC<TableProps> = ({ users }) => {
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
          {users.map((user) => (
            <User key={user.id} user={user} />
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Table;
