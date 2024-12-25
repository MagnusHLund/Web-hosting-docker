import { FaEllipsisV } from "react-icons/fa";
import { useState } from "react";
import "./Menu.scss";
import Button from "../input/Button";

const Menu: React.FC = () => {
  const [isOpen, setIsOpen] = useState(false);

  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  return (
    <div className="menu">
      {isOpen && <div onClick={toggleMenu} className="menu__background" />}
      <div className="menu__icon" onClick={toggleMenu}>
        <FaEllipsisV className="menu__icon-svg" />
      </div>
      {isOpen && (
        <ul className="menu__list">
          <li className="menu__item">
            <Button
              text="Git pull"
              onClick={() => {
                /* Handle Git pull action */
              }}
            />
          </li>
          <li className="menu__item">
            <Button
              text="Edit"
              onClick={() => {
                /* Handle Edit action */
              }}
            />
          </li>
          <li className="menu__item">
            <Button
              text="Disable"
              onClick={() => {
                /* Handle Disable action */
              }}
            />
          </li>
          <li className="menu__item menu__item--delete">
            <Button
              text="Delete"
              onClick={() => {
                /* Handle Delete action */
              }}
              backgroundColor="red"
            />
          </li>
        </ul>
      )}
    </div>
  );
};

export default Menu;
