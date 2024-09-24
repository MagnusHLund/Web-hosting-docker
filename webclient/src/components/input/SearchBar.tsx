import { useState, useEffect } from "react";
import "./SearchBar.scss"; // Ensure you create this file for specific styles

const SearchBar: React.FC = () => {
  const [query, setQuery] = useState("");

  useEffect(() => {
    console.log("Search query:", query);
  }, [query]);

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setQuery(event.target.value);
  };

  return (
    <div className="search-bar">
      <input
        type="text"
        value={query}
        onChange={handleChange}
        placeholder="Search..."
        className="search-input"
      />
    </div>
  );
};

export default SearchBar;
