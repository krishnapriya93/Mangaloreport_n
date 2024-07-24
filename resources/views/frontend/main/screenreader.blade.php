@extends('frontend.layouts.main_header')
@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <div class="container" style="margin-top:10px;">
        <div class="one text-col px-5 mt-3 mb-4">
            <h1>Screen Reader Access</h1>
        </div>
        <table id="screen-readers" class="display">
            <thead>
                <tr>
                    <th>Screen Reader</th>
                    <th>Website</th>
                    <th>Free / Commercial</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Windows Narrator (Windows only)</td>
                    <td><a
                            href="http://www.microsoft.com/enable/training/windowsxp/usingnarrator.aspx">http://www.microsoft.com/enable/training/windowsxp/usingnarrator.aspx</a>
                    </td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td>Non Visual Desktop Access (NVDA)</td>
                    <td><a href="http://www.nvda-project.org/">http://www.nvda-project.org/</a></td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td>System Access To Go</td>
                    <td><a href="http://www.satogo.com/">http://www.satogo.com/</a></td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td><a
                            href="http://www.yourdolphin.co.uk/productdetail.asp?id=5">http://www.yourdolphin.co.uk/productdetail.asp?id=5</a>
                    </td>
                    <td>Commercial</td>
                </tr>
                <tr>
                    <td>JAWS</td>
                    <td><a href="http://www.freedomscientific.com">http://www.freedomscientific.com</a></td>
                    <td>Commercial</td>
                </tr>
                <tr>
                    <td>Supernova</td>
                    <td><a
                            href="http://www.yourdolphin.co.uk/productdetail.asp?id=1">http://www.yourdolphin.co.uk/productdetail.asp?id=1</a>
                    </td>
                    <td>Commercial</td>
                </tr>
                <tr>
                    <td>Window-Eyes</td>
                    <td><a href="http://www.gwmicro.com/Window-Eyes/">http://www.gwmicro.com/Window-Eyes/</a></td>
                    <td>Commercial</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('page_scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#screen-readers').DataTable();
        });
    </script>
@endsection
