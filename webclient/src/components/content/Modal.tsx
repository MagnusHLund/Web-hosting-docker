import "./Modal.scss";

interface ModalProps {
  title?: string;
  showTitle?: boolean;
  onClose: () => void;
  children: React.ReactNode;
}

const Modal: React.FC<ModalProps> = ({
  title = "Modal",
  showTitle = true,
  onClose,
  children,
}) => {
  return (
    <>
      <div className="modal__background" onClick={onClose}></div>
      <div className="modal">
        <div className="modal__header">
          {showTitle && <h2 className="modal__title">{title}</h2>}
          <button className="modal__close" onClick={onClose}>
            X
          </button>
        </div>
        <div className="modal__body">{children}</div>
      </div>
    </>
  );
};

export default Modal;
