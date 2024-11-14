import "./Button.scss";

interface ButtonProps {
  text: string; // Prop for the button text
  onClick?: () => void; // Optional onClick handler
  backgroundColor?: string; // Optional background color
  textColor?: string; // Optional text color
}

const Button: React.FC<ButtonProps> = ({
  text,
  onClick,
  backgroundColor,
  textColor,
}) => {
  const buttonStyle = {
    backgroundColor: backgroundColor || "blue", // Fallback to default if not provided
    color: textColor || "white", // Fallback to default if not provided
  };

  return (
    <button className="responsive-button" onClick={onClick} style={buttonStyle}>
      {text}
    </button>
  );
};

export default Button;
