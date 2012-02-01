<%@ Page Language="C#" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script runat="server">
    protected void Page_Load(object sender, EventArgs e)
    {
        //URL to get here should include the following QueryString variables:
        //WebinarKey == ID for webinar, get from end of GTW registration URL
        //redirect == URL to redirect lead/registrant to after submission to GTW, minus http://
        
        if (Request.QueryString["WebinarKey"] != "" && Request.QueryString["WebinarKey"] != null)
        {
            System.Text.StringBuilder GTWoutput = new System.Text.StringBuilder();

            //GTW form elements
            GTWoutput.Append("WebinarKey=" + Server.UrlEncode(Request.QueryString["WebinarKey"].ToString()));
            GTWoutput.Append("&Form=webinarRegistrationForm");
            GTWoutput.Append("&Name_First=" + Server.UrlEncode(Request.QueryString["FirstName"].ToString()));
            GTWoutput.Append("&Name_Last=" + Server.UrlEncode(Request.QueryString["LastName"].ToString()));
            GTWoutput.Append("&Email=" + Server.UrlEncode(Request.QueryString["Email"].ToString()));

            if (Request.QueryString["Company"] != "" && Request.QueryString["Company"] != null)
            {
                GTWoutput.Append("&Organization=" + Server.UrlEncode(Request.QueryString["Company"].ToString()));
            }

            if (Request.QueryString["City"] != "" && Request.QueryString["City"] != null)
            {
                GTWoutput.Append("&Address_City=" + Server.UrlEncode(Request.QueryString["City"].ToString()));
            }

            //get POST URL for GTW
            string GTWurl = "https://www.gotomeeting.com/en_US/island/webinar/registration.flow";

            //build submission request
            System.Net.HttpWebRequest GTWreq = (System.Net.HttpWebRequest)System.Net.WebRequest.Create(GTWurl);
            GTWreq.Method = "POST"; //must HTTP POST to GTW
            GTWreq.ProtocolVersion = System.Net.HttpVersion.Version10; //ASP.Net's implementation of HTTP 1.1 adds a layer that is impossible to work around
            GTWreq.ContentType = "application/x-www-form-urlencoded"; //look like a form submission
            GTWreq.KeepAlive = false; //don't wait for a call back

            byte[] buffer = Encoding.ASCII.GetBytes(GTWoutput.ToString()); //convert our "form" to a stream-readable format
            GTWreq.ContentLength = buffer.Length;

            //stream out data over request       
            System.IO.Stream PostData = GTWreq.GetRequestStream();
            PostData.Write(buffer, 0, buffer.Length); //write to GTW
            PostData.Close();

            System.Net.HttpWebResponse WebResp = (System.Net.HttpWebResponse)GTWreq.GetResponse(); //get a response from GTW for our request - this CONFIRMS the registration

            //redirect to the designated URL, or the homepage of the sending URL
            if (Request.QueryString["redirect"] == "" || Request.QueryString["redirect"] == null)
            {
                Response.Redirect("http://" + Request.UrlReferrer.Host.ToString());
            }
            else
            {
                Response.Redirect("http://" + Request.QueryString["redirect"]);
            }
        } 
    }
</script>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form id="form1" runat="server">
    <div>

    </div>
    </form>
</body>
</html>