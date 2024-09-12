import "./Header.scss";
import HeaderOption from "./HeaderOption";
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
        <HeaderOption />
      </div>
    </header>
  );
}

export default Header;
