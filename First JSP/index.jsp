<%@ page import="java.sql.*" %>
<%@ page import="javax.servlet.*" %>
<%@ page import="javax.servlet.http.*" %>
<html>
<body>

<%
    String action = request.getParameter("action");

    if(action != null) {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pragati", "root", "");

            String stud_id = request.getParameter("stud_id");
            String name = request.getParameter("name");
            String className = request.getParameter("class");
            String division = request.getParameter("division");
            String city = request.getParameter("city");

            if("insert".equals(action)) {
                PreparedStatement ps = con.prepareStatement("INSERT INTO stud_info (stud_id, name, class, division, city) VALUES (?, ?, ?, ?, ?)");
                ps.setString(1, stud_id);
                ps.setString(2, name);
                ps.setString(3, className);
                ps.setString(4, division);
                ps.setString(5, city);

                int i = ps.executeUpdate();
                if(i > 0){
                    out.println("<p>Record inserted successfully!</p>");
                } else {
                    out.println("<p>Insertion failed.</p>");
                }
            } else if("update".equals(action)) {
                PreparedStatement ps = con.prepareStatement("UPDATE stud_info SET name=?, class=?, division=?, city=? WHERE stud_id=?");
                ps.setString(1, name);
                ps.setString(2, className);
                ps.setString(3, division);
                ps.setString(4, city);
                ps.setString(5, stud_id);

                int i = ps.executeUpdate();
                if(i > 0){
                    out.println("<p>Record updated successfully!</p>");
                } else {
                    out.println("<p>Update failed. Student not found!</p>");
                }
            } else if("delete".equals(action)) {
                PreparedStatement ps = con.prepareStatement("DELETE FROM stud_info WHERE stud_id=?");
                ps.setString(1, stud_id);

                int i = ps.executeUpdate();
                if(i > 0){
                    out.println("<p>Record deleted successfully!</p>");
                } else {
                    out.println("<p>Deletion failed. Student not found!</p>");
                }
            }

            con.close();
        } catch(Exception e) {
            out.println(e);
        }
    }
%>

<h2>Student Record Management (Insert / Update / Delete)</h2>

<form method="post">
    <label>Action:</label>
    <select name="action" required>
        <option value="">--Select--</option>
        <option value="insert">Insert</option>
        <option value="update">Update</option>
        <option value="delete">Delete</option>
    </select>
    <br><br>

    Stud_id: <input type="text" name="stud_id" required><br><br>
    Name: <input type="text" name="name"><br><br>
    Class: <input type="text" name="class"><br><br>
    Division: <input type="text" name="division"><br><br>
    City: <input type="text" name="city"><br><br>

    <input type="submit" value="Submit">
</form>


</body>
</html>
