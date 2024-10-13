import { Link } from "react-router-dom";
import "./Navbar.scss";

// Define the type for the routes prop
interface RouteProps {
  path: string;
  name: string;
}

// Define the type for the Navbar props
interface NavbarProps {
  routes: RouteProps[];
}

const Navbar: React.FC<NavbarProps> = ({ routes }) => {
  return (
    <nav className="navbar">
      <ul className="navbar__list">
        {routes.map((route, index) =>
          // Check if the route name is "Login"
          route.name === "Login" ? null : (
            <li key={index} className="navbar__item">
              <Link to={route.path} className="navbar__link">
                {route.name}
              </Link>
            </li>
          )
        )}
      </ul>
    </nav>
  );
};

export default Navbar;
