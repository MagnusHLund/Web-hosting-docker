export const saveSettingsToLocalStorage = (
  theme: "light" | "dark",
  language: "da_DK" | "en_US",
  expiration: number
) => {
  const settings = {
    settings: {
      theme,
      language,
    },
    expiration,
  };
  localStorage.setItem("settings", JSON.stringify(settings));
};

export const loadSettingsFromLocalStorage = () => {
  const storedSettings = JSON.parse(localStorage.getItem("settings") || "{}");
  return {
    theme: storedSettings.settings?.theme || "light",
    language: storedSettings.settings?.language || "da_DK",
    expiration: storedSettings.expiration || 0,
  };
};
