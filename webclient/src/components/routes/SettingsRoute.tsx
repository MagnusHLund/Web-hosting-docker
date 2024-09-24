import SearchBar from "../input/SearchBar";
import Toggle from "../input/Toggle";
import "./SettingsRoute.scss";

const Settings: React.FC = () => {
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
          <select className="language-select" defaultValue="english">
            <option value="english">English</option>
            <option value="dansk">Dansk</option>
          </select>
        </div>
      </div>
    </div>
  );
};

export default Settings;
