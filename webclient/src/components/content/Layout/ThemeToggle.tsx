import { useDispatch, useSelector } from 'react-redux';
import { toggleTheme } from '../../../redux/Slices/themeSlice';
import { RootState } from '../../../redux/Store'; 
import './ThemeToggle.scss';

function ThemeToggle() {
  const dispatch = useDispatch();
  const theme = useSelector((state: RootState) => state.theme.theme);

  const handleThemeToggle = () => {
    dispatch(toggleTheme());
  };

  return (
    <button className="theme-toggle" onClick={handleThemeToggle}>
      {theme === 'light' ? 'Switch to Dark' : 'Switch to Light'}
    </button>
  );
}

export default ThemeToggle;
