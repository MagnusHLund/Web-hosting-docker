import React from "react";
import "./Table.scss";

interface TableProps {
  headers: string[];
  rows: Array<React.ReactNode>;
}

const Table: React.FC<TableProps> = ({ headers, rows }) => {
  return (
    <div className="table-container">
      <table className="table">
        <thead className="table__header">
          <tr className="table__header-row">
            {headers.map((header, index) => (
              <th key={index} className="table__header-cell">
                {header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className="table__body">
          {rows.map((row, index) => (
            <tr key={index} className="table__body-row">
              {row}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Table;
