import { useState, useEffect } from "react";
import "./ThemeToggle.scss"; // Import the SCSS for styling

const ThemeToggle: React.FC = () => {
  const [isDarkTheme, setIsDarkTheme] = useState<boolean>(() => {
    // Check localStorage for the theme preference
    const savedTheme = localStorage.getItem("theme");
    return savedTheme === "dark";
  });
  
  const toggleTheme = () => {
    setIsDarkTheme(!isDarkTheme);
  };

  useEffect(() => {
    if (isDarkTheme) {
      document.body.classList.add("dark-theme");
      localStorage.setItem("theme", "dark"); // Save to localStorage
    } else {
      document.body.classList.remove("dark-theme");
      localStorage.setItem("theme", "light"); // Save to localStorage
    }
  }, [isDarkTheme]);

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
