import "./Header.scss";
import LogoArea from "./LogoArea";

function Header() {
  return (
    <header className="header">
      <div className="header__logo">
        <LogoArea />
      </div>

      <div className="header__Options">
        <div className="header__Options__box">User</div>
        <div className="header__Options__box">User Role</div>
      </div>
    </header>
  );
}

export default Header;
