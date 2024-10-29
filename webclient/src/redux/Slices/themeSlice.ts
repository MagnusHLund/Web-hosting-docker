import { createSlice } from "@reduxjs/toolkit";
import {
  saveSettingsToLocalStorage,
  loadSettingsFromLocalStorage,
} from "../localStorageHelper";

interface ThemeState {
  theme: "light" | "dark";
  expiration: number;
}

// Load theme settings directly from local storage
const { theme, expiration } = loadSettingsFromLocalStorage();
const initialState: ThemeState = {
  theme,
  expiration,
};

const themeSlice = createSlice({
  name: "theme",
  initialState,
  reducers: {
    toggleTheme: (state) => {
      // Toggle the theme directly on `state.theme`
      state.theme = state.theme === "light" ? "dark" : "light";
      state.expiration = Date.now(); // Update expiration
      saveSettingsToLocalStorage(
        state.theme,
        loadSettingsFromLocalStorage().language,
        state.expiration
      );
    },
    setTheme: (state, action) => {
      // Set the theme and update expiration directly
      state.theme = action.payload;
      state.expiration = Date.now();
      saveSettingsToLocalStorage(
        state.theme,
        loadSettingsFromLocalStorage().language,
        state.expiration
      );
    },
  },
});

export const { toggleTheme, setTheme } = themeSlice.actions;
export default themeSlice.reducer;
