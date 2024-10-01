import { FaEllipsisV } from "react-icons/fa";
import { useState } from "react";
import "./Menu.scss";

const Menu = () => {
  const [isOpen, setIsOpen] = useState(false);

  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  return (
    <>
      {isOpen && <div onClick={toggleMenu} className="backgroundDiv"></div>}
      <div className="menu">
        <div className="menu__icon" onClick={toggleMenu}>
          <FaEllipsisV className="table__action-icon" />
          {isOpen && (
            <ul className="menu__list">
              <li className="menu__item">Git pull</li>
              <li className="menu__item">Edit</li>
              <li className="menu__item">Disable</li>
              <li className="menu__item menu__item--delete">Delete</li>
            </ul>
          )}
        </div>
      </div>
    </>
  );
};

export default Menu;
