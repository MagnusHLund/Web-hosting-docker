import Menu from "./Menu";
import "./User.scss";

interface UserProps {
  user: {
    id: number;
    name: string;
    email: string;
    role: string;
    status: string;
  };
}

const User: React.FC<UserProps> = ({ user }) => {
  return (
    <tr className="table__body-row">
      <td className="table__body-cell">{user.name}</td>
      <td className="table__body-cell">{user.email}</td>
      <td className="table__body-cell">{user.role}</td>
      <td className="table__body-cell">{user.status}</td>
      <td className="table__body-cell">
        <Menu />
      </td>
    </tr>
  );
};

export default User;
