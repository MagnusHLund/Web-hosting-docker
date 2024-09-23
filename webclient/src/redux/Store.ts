import { configureStore } from '@reduxjs/toolkit'
import themeSlice from './Slices/themeSlice'
import languageSlice from './Slices/LanguageSlice'

export const store = configureStore({
  reducer: {
    theme: themeSlice,
    language: languageSlice,
  },
})

export interface RootState {
  theme: ReturnType<typeof themeSlice>
  language: ReturnType<typeof languageSlice>
}

export type AppDispatch = typeof store.dispatch
