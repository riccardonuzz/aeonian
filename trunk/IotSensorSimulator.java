import java.io.DataOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.*;
import java.util.HashMap;
import java.util.Scanner;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

public class IotSensorSimulator {
	
	public static void main(String[] args) {
		// sezione dichiarazione variabili locali
		
		Scanner inputStream = null;
		
		String configFile = "config.php";		
		String ssl = "false";
		
		int intervalloRilevazione = 5;
		
		/*
		 * 	Dichiarazione ed inizializzazione della Mappa
		 */
		
		HashMap<String, String> config = new HashMap<String, String>();
		
		config.put("DB_HOST", null);
		config.put("DB_USER", null);
		config.put("DB_PASS", null);
		config.put("DB_NAME", null);
		config.put("ROOT_URL", null);
			
		/*
		 * 	Apertura del file di configurazione
		 */
		
		try {
			inputStream = new Scanner ( new File ( configFile ) );
		}
		catch (FileNotFoundException e ) {
			System.out.println ("File di configurazione non trovato.");
			System.exit(0);
		}
		
		/*
		 * 	Ricerca corrispondenza tra valori di configurazione e file di configurazione
		 */
		
		while ( inputStream.hasNextLine() ) {
	
			String riga = inputStream.nextLine();
					
			if( riga.contains("define") && !(riga.startsWith("//") ) ) {
		
				String key = riga.split("\"")[1];
				String value = riga.split("\"")[3];
	
				if( config.containsKey( key ) ) {
					config.put( key, value );
					System.out.println( "Acquisizione chiave \"" + key + "\"" );
				}
			}
		}
	
		inputStream.close();
			
		/*
		 *  Acquisizione della lista dei sensori installati presso gli impianti
		 */
		
		Connection connessione = null;

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
			connessione = DriverManager.getConnection("jdbc:mysql://localhost/" + config.get( "DB_NAME" ) + "?useSSL=" + ssl , config.get( "DB_USER" ), config.get( "DB_PASS" ) );
		
			if (connessione != null) {
                System.out.println( "Connesso al database \"" + config.get( "DB_NAME" ) + "\"." );
            }		
			
			// esecuzione comando SQL
			Statement istruzione = connessione.createStatement();
			ResultSet risultato = istruzione.executeQuery(stringa);
	
			System.out.println( "Simulazione ed invio delle rilevazioni in corso. L\'intervallo di rilevazione è di n." + intervalloRilevazione + " secondi.");
	
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

							System.out.println( "Sensore: " + IDSensore + " - Range dei valori ammessi:  " + Minimo + " - " + Massimo + ". Valore rilevato: " + randomString );
							
							// Url di destinazione
					
							String url = config.get("ROOT_URL") + "/template/user-contents/outputs-receptor.php?rilevazione=" + output;	

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
