import { useState } from "react";
import { Link } from "react-router-dom";
import { HiDotsVertical } from "react-icons/hi";
import "./HeaderInfo.scss";

const HeaderInfo: React.FC = () => {
  const [isVisible, setIsVisible] = useState(false);
  const [selectedLanguage, setSelectedLanguage] = useState("");

  const toggleInfo = () => {
    setIsVisible(!isVisible);
  };

  const handleChange = (event: React.ChangeEvent<HTMLSelectElement>) => {
    const language = event.target.value;
    setSelectedLanguage(language);
    console.log(`Selected language: ${language}`);
  };

  return (
    <div className="header-info">
      {/* Button to trigger the info div */}
      <button className="header-info__toggle" onClick={toggleInfo}>
        <HiDotsVertical />
      </button>

      {/* Conditionally render the info div */}
      {isVisible && (
        <div className="header-info__menu">
          <div className="header-info__item">
            <select
              className="header-info__language-option"
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
          <Link to="/settings" className="header-info__item">
            Settings
          </Link>
        </div>
      )}
    </div>
  );
};

export default HeaderInfo;
