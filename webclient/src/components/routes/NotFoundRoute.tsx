import "./NotFoundRoute.scss"; // SCSS file for styling

function NotFoundRoute() {
  return (
    <main className="not-found">
      <div className="not-found__content">
        <p className="not-found__title">404</p>
        <p className="not-found__message">This route does not exist</p>
        <div className="not-found__link">
          <a href="/">Go back to Home </a>
        </div>
      </div>
    </main>
  );
}

export default NotFoundRoute;
