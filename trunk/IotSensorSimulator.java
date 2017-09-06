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
		
		/*
		 * 	Lettura dei parametri di configurazione dal file config.php
		 */

		
		/*
		 *  Acquisizione della lista dei sensori installati presso gli impianti
		 */
		
		Connection connessione = null;

		String username = "root";
		String password = "";
		String database = "iot_database";
		String ssl = "false";
		int intervalloRilevazione = 5;

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
			connessione = DriverManager.getConnection("jdbc:mysql://localhost/" + database + "?useSSL=" + ssl , username, password);
		
			if (connessione != null) {
                System.out.println( "\n Connesso al database: " + database );
            }		
			
			// esecuzione comando SQL
			Statement istruzione = connessione.createStatement();
			ResultSet risultato = istruzione.executeQuery(stringa);
	
			System.out.println( "\n Generazione ed invio delle rilevazioni in corso. Intervallo di rilevazione n." + intervalloRilevazione + " secondi.");
	
			Runnable runnable = new Runnable() {
				
			      public void run() {

			        // TODO
				        
					try {
						while ( risultato.next() ) {
							
							String IDSensore = risultato.getString("IDSensore");
							float Minimo = risultato.getFloat("Minimo");
							float Massimo = risultato.getFloat("Massimo");	
							
							float random =  (float) (Minimo + Math.random() * ( Massimo - Minimo ));					
							String randomString = String.format("%1.2f", random);
							
							String output = (IDSensore + "-" + randomString );

							System.out.print( "\n Sensore: " + IDSensore + ". Min: " + Minimo + ". Max: " + Massimo + ". Valore rilevato: " + randomString );
							
							// Url di destinazione
					
							String url = "http://dev/aeonian/template/user-contents/outputs-receptor.php?rilevazione=" + output;	
							
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
							
							System.out.println(". Risposta del server: " + con.getResponseCode() + " - " + con.getResponseMessage() + ".");
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
			    service.scheduleAtFixedRate(runnable, 0, intervalloRilevazione, TimeUnit.SECONDS);
		} 
		catch (SQLException e) {
			e.printStackTrace();
		}

	}

}
