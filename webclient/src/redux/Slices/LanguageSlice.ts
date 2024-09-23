import { createSlice } from '@reduxjs/toolkit'

export type Language = 'da_DK' | 'en_US'

export interface LanguageProps {
  languages: Language[]
  current: number
}

const initialState: LanguageProps = {
  languages: ['da_DK', 'en_US'],
  current: 0,
}

const languageSlice = createSlice({
  name: 'language',
  initialState: initialState,
  reducers: {
    changeLanguage: (state) => {
      state.current = (state.current + 1) % state.languages.length
    },
  },
})

export const { changeLanguage } = languageSlice.actions
export default languageSlice.reducer
