import LogoArea from "./LogoArea";
import "./Header.scss";
import ThemeToggle from "./ThemeToggle";

function Header() {
  return (
    <header className="header">
      <div className="header__logo">
        <LogoArea />
      </div>
      <div className="header__user-info">
        <ThemeToggle />
        <div className="header__user-info__role">
          <div className="header__user-info__role__box">User</div>
          <div className="header__user-info__role__box">User Role</div>
        </div>
      </div>
    </header>
  );
}

export default Header;
