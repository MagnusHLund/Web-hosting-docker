import "./Header.scss";
import LogoArea from "./LogoArea";

function Header() {
  return (
    <header className="header">
      <div className="header__logo">
        <LogoArea />
      </div>

      <div className="header__Info">
        <img className="header__Info__icon" src="/user.svg" />
        <div className="header__Info__box">User</div>
        <div className="header__Info__box">User Role</div>
      </div>
    </header>
  );
}

export default Header;
