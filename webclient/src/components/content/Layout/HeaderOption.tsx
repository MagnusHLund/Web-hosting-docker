import { HtmlHTMLAttributes, useState } from "react";
import { Link } from "react-router-dom";
import { HiDotsVertical } from "react-icons/hi";
import "./HeaderOption.scss";
import ThemeToggle from "./ThemeToggle";

const HeaderOption: React.FC = () => {
  const [isVisible, setIsVisible] = useState(false);

  const [selectedLanguage, setSelectedLanguage] = useState("");

  const toggleOptions = () => {
    setIsVisible(!isVisible);
  };

  const handleChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
    const language = event.target.value;
    setSelectedLanguage(language);
    console.log(`Selected language: ${language}`);
  };

  return (
    <div className="header-option">
      {/* Button to trigger the options div */}
      <button className="header-option__toggle" onClick={toggleOptions}>
        <HiDotsVertical />
      </button>

      {/* Conditionally render the options div */}
      {isVisible && (
        <div className="header-option__menu">
          <div className="header-option__item">
            <ThemeToggle />
          </div>
          <div className="header-option__item">
            <select
              className="header-option__item__Language-Option"
              value={selectedLanguage}
              onChange={handleChange}
            >
              <option value="" disabled>
                Language
              </option>
              <option value="English">English</option>
              <option value="Dansk">Dansk</option>
            </select>
          </div>
          <Link to="/settings" className="header-option__item">
            Settings
          </Link>
        </div>
      )}
    </div>
  );
};

export default HeaderOption;
