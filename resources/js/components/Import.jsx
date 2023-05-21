import React from "react";
import ReactDOM from "react-dom";
import Swal from "sweetalert2";
// import swalWithBootstrapButtons from "sweetalert2";

function Import(props) {
    const destroy = (e) => {
        const afterDelete = e.currentTarget.parentNode.parentNode.parentNode;
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to continue",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(props.endpoint).then((response) => {
                    afterDelete.remove();
                    swalWithBootstrapButtons.fire("Deleted!", "Your file has been deleted.", "success");
                });
            }
        });
    };

    return (
        <button onClick={destroy} className="btn btn-danger btn-sm">
            Hapus
        </button>
    );
}

export default Import;

if (document.querySelectorAll(".delete")) {
    const deleteNodes = document.querySelectorAll(".delete");
    deleteNodes.forEach((item) => {
        var endpoint = item.getAttribute("endpoint");
        ReactDOM.render(<Delete endpoint={endpoint} />, item);
    });
}
