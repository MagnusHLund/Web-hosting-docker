import { createSlice } from "@reduxjs/toolkit";
import {
  saveSettingsToLocalStorage,
  loadSettingsFromLocalStorage,
} from "../localStorageHelper";

export type Language = "da_DK" | "en_US";

export interface LanguageProps {
  languages: Language[];
  current: number;
}

const { language } = loadSettingsFromLocalStorage();
const initialState: LanguageProps = {
  languages: ["da_DK", "en_US"],
  current: language === "en_US" ? 1 : 0,
};

const languageSlice = createSlice({
  name: "language",
  initialState,
  reducers: {
    changeLanguage: (state) => {
      state.current = (state.current + 1) % state.languages.length;
      const expiration = Date.now();
      saveSettingsToLocalStorage(
        loadSettingsFromLocalStorage().theme,
        state.languages[state.current],
        expiration
      );
    },
    setLanguage: (state, action) => {
      state.current = action.payload;
      const expiration = Date.now();
      saveSettingsToLocalStorage(
        loadSettingsFromLocalStorage().theme,
        state.languages[state.current],
        expiration
      );
    },
  },
});

export const { changeLanguage, setLanguage } = languageSlice.actions;
export default languageSlice.reducer;
