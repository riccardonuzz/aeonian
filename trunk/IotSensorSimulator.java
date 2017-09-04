import java.io.DataOutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.*;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

public class IotSensorSimulator {
	
	public static void main(String[] args) {
		// sezione dichiarazione variabili locali
		
		Connection connessione = null;

		String username = "root";
		String password = "";

		String stringa =	"SELECT s.IDSensore IDSensore, t.Nome TipologiaSensore, s.Minimo Minimo, s.Massimo Massimo " +
							"FROM sensore s " + 
							"JOIN ambiente a on s.Ambiente = a.IDAmbiente " +
							"JOIN impianto i on a.Impianto = i.IDImpianto " +
							"JOIN tipologiasensore t on s.TipologiaSensore = t.IDTipologiaSensore " +
						//	"WHERE i.IDImpianto = 1 " +
							"ORDER BY s.TipologiaSensore";

		try {
			// caricamento del driver
			new com.mysql.jdbc.Driver();
			/*
			 * creazione di una connessione al database
			 */
			connessione = DriverManager.getConnection("jdbc:mysql://localhost/iot_database?useSSL=false", username, password);
		
			if (connessione != null) {
                System.out.println("\n Connected to the database iot_database");
            }		
			
			// esecuzione comando SQL
			Statement istruzione = connessione.createStatement();
			ResultSet risultato = istruzione.executeQuery(stringa);
	
			System.out.println("\n Selezione dei sensori relativi all'impianto");
	
			Runnable runnable = new Runnable() {
				
			      public void run() {

			        // task to run goes here
				        
					try {
						while ( risultato.next() ) {
							
							String IDSensore = risultato.getString("IDSensore");
							float Minimo = risultato.getFloat("Minimo");
							float Massimo = risultato.getFloat("Massimo");	
							
							float random =  (float) (Minimo + Math.random() * ( Massimo - Minimo ));					
							String randomString = String.format("%1.2f", random);
							
							String output = (IDSensore + "-" + randomString );

							// Url di destinazione
					
							String url = "http://dev/aeonian/template/user-contents/outputs-receptor.php?rilevazione=" + output;
							System.out.println(url);	
							
							URL turl = new URL( url );
							HttpURLConnection con = (HttpURLConnection) turl.openConnection();
							
							con.setRequestMethod("GET");
							
							con.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");
							con.setRequestProperty("Content-Length", Integer.toString(output.getBytes().length));
							con.setRequestProperty("Content-Language", "it-IT");
							
							con.setUseCaches(false);
							con.setDoOutput(true);
							
							DataOutputStream out = new DataOutputStream(con.getOutputStream());
							out.writeBytes(output);
							out.close();
							
							System.out.println(con.getResponseCode());
							System.out.println(con.getResponseMessage());
			
						}
					} catch (Exception e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					} 
					try {
						risultato.beforeFirst();
					} catch (SQLException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}	            
			      }
			    };
				
			    ScheduledExecutorService service = Executors.newSingleThreadScheduledExecutor();
			    service.scheduleAtFixedRate(runnable, 0, 5, TimeUnit.SECONDS);
		} 
		catch (SQLException e) {
			e.printStackTrace();
		}

	}

}
