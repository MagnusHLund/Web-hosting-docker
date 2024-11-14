import { toggleTheme } from "../../redux/Slices/themeSlice";
import { useDispatch } from "react-redux";
import { useEffect } from "react";
import "./Toggle.scss";

const Toggle = () => {
  // this will change the redux value
  const dispatch = useDispatch();

  const handleThemeToggle = () => {
    dispatch(toggleTheme());
  };

  // this is for the toggle button styling
  useEffect(() => {
    const toggleElement = document.querySelector(".toggle");

    const handleClick = () => {
      if (toggleElement) {
        // Check if toggleElement is not null
        toggleElement.classList.toggle("active");
      }
    };

    toggleElement?.addEventListener("click", handleClick);

    // Cleanup event listener on component unmount
    return () => {
      toggleElement?.removeEventListener("click", handleClick);
    };
  }, []);

  return (
    <button onClick={handleThemeToggle} className="toggle">
      <div className="toggle__circle"></div>
    </button>
  );
};

export default Toggle;
