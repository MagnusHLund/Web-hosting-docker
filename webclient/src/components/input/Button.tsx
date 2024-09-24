import "./Button.scss";

interface ButtonProps {
  text: string; // Prop for the button text
  onClick?: () => void; // Optional onClick handler
}

const Button: React.FC<ButtonProps> = ({ text, onClick }) => {
  return (
    <button className="responsive-button" onClick={onClick}>
      {text}
    </button>
  );
};

export default Button;
