import React, { createContext, useState, useContext, ReactNode } from "react";

// Define the context and its default value
const ThemeContext = createContext({
  isDarkTheme: false,
  toggleTheme: () => {},
});

interface ThemeProviderProps {
  children: ReactNode;
}

// Create a provider component
export const ThemeProvider: React.FC<ThemeProviderProps> = ({ children }) => {
  const [isDarkTheme, setIsDarkTheme] = useState<boolean>(() => {
    const savedTheme = localStorage.getItem("theme");
    return savedTheme === "dark";
  });

  const toggleTheme = () => {
    setIsDarkTheme((prev) => {
      const newTheme = !prev;
      localStorage.setItem("theme", newTheme ? "dark" : "light");
      return newTheme;
    });
  };

  return (
    <ThemeContext.Provider value={{ isDarkTheme, toggleTheme }}>
      {children}
    </ThemeContext.Provider>
  );
};

// Custom hook for using the context
export const useTheme = () => useContext(ThemeContext);
