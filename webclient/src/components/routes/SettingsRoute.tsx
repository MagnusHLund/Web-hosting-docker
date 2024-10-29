import React from "react";
import { useDispatch, useSelector } from "react-redux";
import SearchBar from "../input/SearchBar";
import Toggle from "../input/Toggle";
import { changeLanguage, setLanguage } from "../../redux/Slices/LanguageSlice";
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
      dispatch(setLanguage(selectedLanguageIndex));
    }
  };

  const handleNextLanguage = () => {
    dispatch(changeLanguage());
  };

  return (
    <div className="settings">
      <div className="settings__header">
        <h2 className="settings__title">Settings</h2>
        <SearchBar />
      </div>
      <div className="settings__options">
        <div className="settings__theme">
          <span className="settings__theme-label">Theme:</span>
          <Toggle />
        </div>
        <div className="settings__language">
          <span className="settings__language-label">Languages:</span>
          <select
            className="settings__language-select"
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
            className="settings__language-button"
          >
            Change Language
          </button>
        </div>
      </div>
    </div>
  );
};

export default Settings;
