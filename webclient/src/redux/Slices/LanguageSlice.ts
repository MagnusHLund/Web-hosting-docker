import { createSlice } from "@reduxjs/toolkit";

export type Language = "da_DK" | "en_US";

export interface LanguageProps {
  languages: Language[];
  current: number;
}

const initialState: LanguageProps = {
  languages: ["da_DK", "en_US"],
  current: parseInt(localStorage.getItem("currentLanguage") || "0", 10), // Load from local storage
};

const languageSlice = createSlice({
  name: "language",
  initialState: initialState,
  reducers: {
    changeLanguage: (state) => {
      state.current = (state.current + 1) % state.languages.length;
      localStorage.setItem("currentLanguage", state.current.toString()); // Save to local storage
    },
    setLanguage: (state, action) => {
      state.current = action.payload; // Set language based on user selection
      localStorage.setItem("currentLanguage", state.current.toString()); // Save to local storage
    },
  },
});

export const { changeLanguage, setLanguage } = languageSlice.actions;
export default languageSlice.reducer;
