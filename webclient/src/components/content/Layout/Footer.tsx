import "./Footer.scss";

const Footer: React.FC = () => {
  return (
    <footer className="footer">
      <div className="footer__content">
        <a
          href="https://www.github.com/magnusHLund/Web-hosting-docker"
          target="_blank"
          className="footer__link"
        >
          Docs
        </a>
        <a
          href="https://www.github.com/magnusHLund/Web-hosting-docker"
          className="footer__link"
          target="_blank"
          rel="noopener noreferrer"
        >
          GitHub
        </a>
      </div>
    </footer>
  );
};

export default Footer;
