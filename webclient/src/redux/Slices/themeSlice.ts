import { createSlice } from "@reduxjs/toolkit";

interface ThemeState {
  theme: "light" | "dark";
  lastChanged: number; // timestamp of the last theme change
}

const initialState: ThemeState = {
  theme: localStorage.getItem("theme") === "dark" ? "dark" : "light",
  lastChanged: parseInt(localStorage.getItem("lastChanged") || "0", 10),
};

// Function to reset the theme if 8 hours have passed
const resetThemeIfExpired = (state: ThemeState) => {
  const currentTime = Date.now();
  const eightHoursInMillis = 8 * 60 * 60 * 1000; // 8 hours in milliseconds

  // Check if the last changed time exceeds 8 hours
  if (currentTime - state.lastChanged > eightHoursInMillis) {
    state.theme = "light"; // Reset to default
    localStorage.setItem("theme", "light");
    localStorage.setItem("lastChanged", currentTime.toString()); // Update last changed time
  }
};

const themeSlice = createSlice({
  name: "theme",
  initialState,
  reducers: {
    toggleTheme: (state) => {
      resetThemeIfExpired(state); // Check for expiry
      state.theme = state.theme === "light" ? "dark" : "light";
      localStorage.setItem("theme", state.theme);
      state.lastChanged = Date.now(); // Update last changed time
      localStorage.setItem("lastChanged", state.lastChanged.toString());
    },
    setTheme: (state, action) => {
      resetThemeIfExpired(state); // Check for expiry
      state.theme = action.payload;
      localStorage.setItem("theme", state.theme);
      state.lastChanged = Date.now(); // Update last changed time
      localStorage.setItem("lastChanged", state.lastChanged.toString());
    },
  },
});

export const { toggleTheme, setTheme } = themeSlice.actions;
export default themeSlice.reducer;
