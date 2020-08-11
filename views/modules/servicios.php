<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="jquery-easyui-1.9.7/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="jquery-easyui-1.9.7/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="jquery-easyui-1.9.7/demo/demo.css">
    <script type="text/javascript" src="jquery-easyui-1.9.7/jquery.min.js"></script>
    <script type="text/javascript" src="jquery-easyui-1.9.7/jquery.easyui.min.js"></script>
</head>

<body>
    <h2>CREAR, MODIFICAR, ELIMINAR Y ACTUALIZAR USUARIOS</h2>
    <table id="dg" title="USUARIOS" class="easyui-datagrid" style="width:700px;height:250px" url="models/cargar.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="EST_CED" width="50">CEDULA</th>
                <th field="EST_NOM" width="50">NOMBRE</th>
                <th field="EST_APE" width="50">APELLIDO</th>
                <th field="EST_DIR" width="50">DIRECCION</th>
                <th field="EST_TEL" width="50">TELEFONO</th>
                <th field="EST_SEX" width="50">SEXO</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">CREAR ESTUDIANTE</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">EDITAR USUARIO</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteAlumno()">ELIMINAR USUARIO</a>
    </div>

    <div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px" action="models/acceso.php">
            <input type="hidden" id="op" name="op" value="insertAlumno">
            <h3>INFORMACION DE USUARIO</h3>
            <div style="margin-bottom:10px">
                <input name="EST_CED" class="easyui-textbox" required="true" label="CEDULA:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="EST_NOM" class="easyui-textbox" required="true" label="NOMBRE:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="EST_APE" class="easyui-textbox" required="true" label="APELLIDO:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="EST_DIR" class="easyui-textbox" required="true" label="DIRECCION:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="EST_TEL" class="easyui-textbox" required="true" label="TELEFONO:" style="width:100%">
            </div>
            <div style="margin-bottom:10px">
                <input name="EST_SEX" class="easyui-textbox" required="true" label="SEXO:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">CREAR</a>
        <a href="#" class="easyui-linkbutton" onclick="clearForm()" style="width:80px">LIMPIAR</a>
    </div>

    <div id="dlgm" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
        <form id="ff" method="post" novalidate style="margin:0;padding:20px 50px" action="models/acceso.php">
            <input type="hidden" id="op" name="op" value="updateAlumno">
            <h3>INFORMACION DE USUARIO</h3>
            <div style="margin-bottom:10px">
                <input name="EST_CED" class="easyui-textbox" required="true" label="CEDULA:" style="width:100%" readonly>
            </div>
            <div style="margin-bottom:10px">
                <input name="EST_NOM" class="easyui-textbox" required="true" label="NOMBRE:" style="width:100%">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="#" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="submitFormUpdate()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>

    <script type="text/javascript">
        var url;

        function newUser() {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'NUEVO USUARIO');
            $('#fm').form('load');
        }

        function submitForm() {
            $('#fm').form('submit');
            $('#fm').form({
                success: function(data) {
                    $("#dg").datagrid("reload");
                    $('#dlg').dialog('close');
                    console.log(data);
                    if (data.indexOf("Error") !== -1)
                        $.messager.alert('Error', data, 'error');
                    else
                        $.messager.alert(data);
                }

            });
        }

        function submitFormUpdate() {
            $('#ff').form('submit');
            $('#ff').form({
                success: function(data) {
                    console.log(data);
                    if (data.indexOf("error") != -1) {
                        $.messager.alert("error", data, "error");

                    } else {
                        $.messager.alert(data);
                    }
                }
            });
        }

        function editUser() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $('#dlgm').dialog('open').dialog('center').dialog('setTitle', 'EDITAR USUARIO');
                $('#ff').form('load', row);
                url = 'update_user.php?id=' + row.id;
            }
        }

        function deleteAlumno() {
            var row = $("#dg").datagrid("getSelected");
            if (row) {
                $.messager.confirm("Confirm", "Desea eliminar el estudiante", function(r) {
                    if (r) {
                        $.post("models/acceso.php", {
                            op: "deleteAlumno",
                            EST_CED: row["EST_CED"]

                        }, function(res) {
                            if (!res.success) {
                                $('#dg').datagrid('reload');
                            } else {
                                $.messager.show({
                                    title: 'correcto',
                                    msg: "Se elimino el estudiante "
                                });
                            }
                            $('#dg').datagrid('reload');
                        }, "json");
                    }
                });

            }
        }

        function destroyAlumno() {
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                $.messager.confirm('Confirm', 'Desea eliminar el estudiante', function(r) {
                    if (r) {
                        $.post("models/acceso.php", {
                            op: "deleteAlumno",
                            CED_EST: row["CED_EST"]
                        }, function(result) {
                            if (!result.success) {
                                $('#dg').datagrid('reload'); // reload the user data
                            } else {
                                $('#dg').datagrid('reload');
                                $.messager.show({ // show error message
                                    title: 'Estudiante eliminado...',
                                    msg: 'Se elimino el usuario'
                                });
                            }
                        }, 'json');
                    }
                });
            }
        }

        function clearForm() {

        }
    </script>
</body>

</html>