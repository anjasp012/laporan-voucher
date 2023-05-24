import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import ReactDOM from "react-dom";

function Example(props) {
    const [laporans, setLaporans] = useState([]);
    const [total, setTotal] = useState('');
    const [jumlah, setJumlah] = useState('');
    const [links, setLinks] = useState([]);
    const [url, setUrl] = useState(props.endpoint);
    const [hari, setHari] = useState();
    const [bulan, setBulan] = useState();
    const [tahun, setTahun] = useState();
    const [title, setTitle] = useState();
    const [paginate, setPaginate] = useState('10');
    const [live, setLive] = useState('');
    const requestFilter = {
        h: hari,
        b: bulan,
        t: tahun,
        paginate: paginate,
        live: live
    };

    const haris = [];
    for (let i = 1; i <= 31; i++) {
        haris.push(<option key={i}>{i}</option>);
    }

    const tahuns = [];
    for (let i = 2017; i <= 2023; i++) {
        tahuns.push(<option key={i}>{i}</option>);
    }

    const getLaporans = async () => {
        try {
            let { data } = await axios.get(url, { params: requestFilter });
            console.log(data);
            setLaporans(data.data);
            data.meta ? setLinks(data.meta.links) : setLinks([]);
            setTotal(data.total);
            setJumlah(data.jumlah);
            setTitle(data.title);
        } catch (error) {
            console.log(error.message);
        }
    };

    const filter = (e) => {
        e.preventDefault();
        getLaporans();
    };

    const importSubmit = async (e)=> {
        e.preventDefault();
        try {
            let config = {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'multipart/form-data',
                  }
            }
            await axios.post('/laporan/import', {laporan : e.target.files[0]}, config);
            window.location = '/laporan';
        } catch (error) {
            console.log(error.message);
        }
    }

    useEffect(() => {
        getLaporans();
        console.log(paginate);
    }, [url, paginate, live]);

    const columns = [
        {
            name: '#',
            // value: 'sa',
            selector: (row, index) => index + 1,
            sortable: true,
        },
        {
            name: 'Tanggal',
            selector: row => row.tanggal,
            sortable: true,
        },
        {
            name: 'waktu',
            selector: row => row.waktu,
            sortable: true,
        },
        {
            name: 'username',
            selector: row => row.username,
            sortable: true,
        },
        {
            name: 'profil',
            selector: row => row.profil,
            sortable: true,
        },
        {
            name: 'komentar',
            selector: row => row.komentar,
            sortable: true,
        },
        {
            name: 'harga',
            selector: row => row.harga,
            sortable: true,
        },
    ];

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="row mb-3 justify-content-between">
                                <div className="col-md-6">
                                    <form onSubmit={filter} className="d-flex gap-2">
                                        <select
                                            value={hari}
                                            onChange={(e) => setHari(e.target.value)}
                                            name="hari"
                                            id="hari"
                                            className="form-select"
                                        >
                                            <option value={null}>Hari</option>
                                            {haris}
                                        </select>
                                        <select
                                            value={bulan}
                                            onChange={(e) => setBulan(e.target.value)}
                                            name="bulan"
                                            id="bulan"
                                            className="form-select"
                                        >
                                            <option value={null}>Bulan</option>
                                            <option value="01">Januari</option>
                                            <option value="02">februari</option>
                                            <option value="03">maret</option>
                                            <option value="04">april</option>
                                            <option value="05">mei</option>
                                            <option value="06">juni</option>
                                            <option value="07">juli</option>
                                            <option value="08">agustus</option>
                                            <option value="09">september</option>
                                            <option value="10">oktober</option>
                                            <option value="11">november</option>
                                            <option value="12">desember</option>
                                        </select>
                                        <select
                                            value={tahun}
                                            onChange={(e) => setTahun(e.target.value)}
                                            name="tahun"
                                            id="tahun"
                                            className="form-select"
                                        >
                                            <option value={null}>Tahun</option>
                                            {tahuns}
                                        </select>
                                        <button className="btn btn-secondary">filter</button>
                                    </form>
                                </div>
                                <div className="col-md-3 text-end">
                                    <form onSubmit={importSubmit}>
                                        <label htmlFor="file" type="button" className="btn btn-success">import</label>
                                        <input id="file" type="file" onChange={importSubmit} className="d-none" />
                                    </form>
                                </div>
                            </div>
                            <div className="d-flex justify-content-between">
                                <div>
                                    <select className="form-select" name="paginate" id="paginate" onChange={(e) => setPaginate(e.target.value)}>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div>
                                    <input type="search" className="form-control" onChange={(e) => setLive(e.target.value)} name="" id="" />
                                </div>
                            </div>
                            <div className="table-responsive mt-3" style={{ maxHeight: '75vh' }}>
                            <table className="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>{title}</th>
                                        <th className="text-end">Total : </th>
                                        <td width={'14%'}>{total}</td>
                                    </tr>
                                </thead>
                            </table>
                            <DataTable columns={columns}
                                    data={laporans}/>
                                    </div>
                                    <div>Total Penjualan : {jumlah}</div>
                                    <nav className="mt-3" aria-label="...">
                                        <ul class="pagination">
                                            {links.length
                                                ? links.map((link, key) => {
                                                    return (
                                                        <li key={key} class={`page-item ${link.active ? "active" : ""}`}>
                                                            <a
                                                                class="page-link"
                                                                href="#"
                                                                onClick={(e) => setUrl(link.url)}
                                                                dangerouslySetInnerHTML={{ __html: link.label }}
                                                            />
                                                        </li>
                                                    );
                                                })
                                                : ""}
                                        </ul>
                                    </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Example;

if (document.getElementById("example")) {
    var item = document.getElementById("example");
    ReactDOM.render(<Example endpoint={item.getAttribute("endpoint")} />, item);
}
