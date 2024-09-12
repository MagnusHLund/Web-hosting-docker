// ThemeToggle.tsx
import { useTheme } from "../../../Hooks/ThemeContext";
import "./ThemeToggle.scss";

const ThemeToggle: React.FC = () => {
  const { isDarkTheme, toggleTheme } = useTheme();

  return (
    <label className="theme-toggle">
      <input
        type="checkbox"
        checked={isDarkTheme}
        onChange={toggleTheme}
        className="theme-toggle__checkbox"
      />
      <span className="theme-toggle__slider"></span>
    </label>
  );
};

export default ThemeToggle;
