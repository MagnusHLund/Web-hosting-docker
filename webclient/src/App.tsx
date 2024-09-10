import "./App.scss";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Navbar from "./components/content/Layout/Navbar";
import LoginRoute from "./components/routes/LoginRoute";
import NotFoundRoute from "./components/routes/NotFoundRoute";
import ServicesRoute from "./components/routes/ServicesRoute";
import SettingsRoute from "./components/routes/SettingsRoute";
import UserRoute from "./components/routes/UsersRoute";
import Header from "./components/content/Layout/Header";
import Settings from "./components/routes/SettingsRoute";

const App: React.FC = () => {
  const routes = [
    { path: "/login", name: "Login", element: <LoginRoute /> },
    { path: "/services", name: "Services", element: <ServicesRoute /> },
    { path: "/settings", name: "Settings", element: <SettingsRoute /> },
    { path: "/user", name: "User", element: <UserRoute /> },
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
