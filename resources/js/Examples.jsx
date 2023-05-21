import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";

function Example(props) {
    const [laporans, setLaporans] = useState([]);
    const [total, setTotal] = useState('');
    const [url, setUrl] = useState(props.endpoint);
    const [hari, setHari] = useState();
    const [bulan, setBulan] = useState();
    const [tahun, setTahun] = useState();
    const [title, setTitle] = useState();
    const requestFilter = {
        h: hari,
        b: bulan,
        t: tahun,
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
            setTotal(data.total);
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
    }, [url]);

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
                            <div className="table-responsive" style={{ maxHeight: '75vh' }}>
                                <table className="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colSpan={5}>{title}</th>
                                            <th colSpan={1} className="text-end">Total : </th>
                                            <td colSpan={2}>Rp.{total}</td>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Username</th>
                                            <th>Profil</th>
                                            <th>Komentar</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {laporans.map((laporan, key) => {
                                            return (
                                                <tr key={laporan.id}>
                                                    <td>{key + 1}</td>
                                                    <td>{laporan.tanggal}</td>
                                                    <td>{laporan.waktu}</td>
                                                    <td>{laporan.username}</td>
                                                    <td>{laporan.profil}</td>
                                                    <td>{laporan.komentar}</td>
                                                    <td>{laporan.harga}</td>
                                                </tr>
                                            );
                                        })}
                                    </tbody>
                                </table>
                            </div>
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
