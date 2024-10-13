import "./App.scss";
import { useEffect } from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Navbar from "./components/content/Layout/Navbar";
import LoginRoute from "./components/routes/LoginRoute";
import NotFoundRoute from "./components/routes/NotFoundRoute";
import ServicesRoute from "./components/routes/ServicesRoute";
import SettingsRoute from "./components/routes/SettingsRoute";
import UserRoute from "./components/routes/UsersRoute";
import Header from "./components/content/Layout/Header";
import { useSelector } from "react-redux";
import { RootState } from "./redux/Store";

const App: React.FC = () => {
  const theme = useSelector((state: RootState) => state.theme.theme);

  useEffect(() => {
    document.body.className = theme === "dark" ? "dark-theme" : "";
  }, [theme]);

  const routes = [
    { path: "/", name: "Services", element: <ServicesRoute /> },
    { path: "/user", name: "User", element: <UserRoute /> },
    { path: "/settings", name: "Settings", element: <SettingsRoute /> },
    { path: "/login", name: "Login", element: <LoginRoute /> },
  ];
  return (
    <>
      <Router>
        <Header />
        <Navbar routes={routes} />
        <Routes>
          {routes.map((route, index) => (
            <Route key={index} path={route.path} element={route.element} />
          ))}
          <Route path="*" element={<NotFoundRoute />} />
        </Routes>
      </Router>
    </>
  );
};

export default App;
