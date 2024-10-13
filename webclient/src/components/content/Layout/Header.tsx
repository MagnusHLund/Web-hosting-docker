import "./Header.scss";
import LogoArea from "./LogoArea";

function Header() {
  return (
    <header className="header">
      <div className="header__logo">
        <LogoArea />
      </div>

      <div className="header__Info">
        <img className="header__Info__icon" src="/user.png" />
        <div className="header__Info__box">User Role</div>
      </div>
    </header>
  );
}

export default Header;
