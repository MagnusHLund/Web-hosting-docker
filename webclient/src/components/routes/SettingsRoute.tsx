import React from "react";
import { useDispatch, useSelector } from "react-redux"; // Import necessary hooks
import SearchBar from "../input/SearchBar";
import Toggle from "../input/Toggle";
import { changeLanguage, setLanguage } from "../../redux/Slices/LanguageSlice"; // Import actions
import "./SettingsRoute.scss";

const Settings: React.FC = () => {
  const dispatch = useDispatch();
  const currentLanguageIndex = useSelector(
    (state: any) => state.language.current
  );
  const languages = useSelector((state: any) => state.language.languages);

  const handleLanguageChange = (
    event: React.ChangeEvent<HTMLSelectElement>
  ) => {
    const selectedLanguageIndex = languages.indexOf(event.target.value as any);
    if (selectedLanguageIndex !== -1) {
      dispatch(setLanguage(selectedLanguageIndex)); // Dispatch action to set selected language
    }
  };

  const handleNextLanguage = () => {
    dispatch(changeLanguage()); // Cycle to the next language
  };

  return (
    <div className="settings-container">
      <div className="settings-header">
        <h2 className="settings-title">Settings</h2>
        <SearchBar />
      </div>
      <div className="settings-options">
        <div className="theme-section">
          <span className="theme-label">Theme:</span>
          <Toggle />
        </div>
        <div className="language-section">
          <span className="language-label">Languages:</span>
          <select
            className="language-select"
            value={languages[currentLanguageIndex]}
            onChange={handleLanguageChange}
          >
            {languages.map((language: any) => (
              <option key={language} value={language}>
                {language === "da_DK" ? "Dansk" : "English"}
              </option>
            ))}
          </select>
          <button
            onClick={handleNextLanguage}
            className="language-change-button"
          >
            Change Language
          </button>
        </div>
      </div>
    </div>
  );
};

export default Settings;
