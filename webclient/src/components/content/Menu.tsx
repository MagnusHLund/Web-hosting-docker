import { FaEllipsisV } from "react-icons/fa";
import { useState } from "react";
import "./Menu.scss";
import Button from "../input/Button";

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
      </div>
    </>
  );
};

export default Menu;
