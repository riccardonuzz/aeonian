import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.Scanner;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class IotSensorSimulator {
	
	public static void main(String[] args) {
		// sezione dichiarazione variabili locali
		
		String http = "http://";
		URL landingPage = null;
		HttpURLConnection con = null;
		BufferedReader in = null;
		String response = null;
		JSONArray json = null;
		int frequenzaRilevazioni = 5;
		String key = "⁠⁠⁠cc5d37435e84b7b46a7963f53393eb40";
		
		System.out.print( "Immettere l\'URL del server di destinazione:\n " + http );

		Scanner tastiera = new Scanner( System.in );
		
		String rootUrl = http + tastiera.nextLine();
		
		try {
			landingPage = new URL( rootUrl + "/landingPage.php?getSensorList=true" );
			con = (HttpURLConnection) landingPage.openConnection();
			in = new BufferedReader(new InputStreamReader(con.getInputStream()));
			response = in.readLine();
			in.close();	
		} catch (IOException e) {
			// TODO Auto-generated catch block
			System.out.println( "Impossibile stabilire una connessione con il server.");
			e.printStackTrace();
			System.exit(0);
		}
		
		System.out.print( "Immettere la frequenza di invio delle rilevazioni (secondi. default: 5): ");
		
		if( tastiera.hasNextInt()) { 
			frequenzaRilevazioni = tastiera.nextInt();
		}
				
		tastiera.close();

		try {
			json = new JSONArray( response );

		} catch ( JSONException e) {
			// TODO Auto-generated catch block
			System.out.println( "Errore nella creazione dell'array JSON.");
			e.printStackTrace();
			System.exit(0);
		}
					
		if ( response == null ) {
			System.out.println( "Non sono stati installati sensori da simulare.");
			System.exit(0);
		}
		System.out.println( "Sono presenti n. " + json.length() + " sensori.\nAvvio della simulazione.\nL\'intervallo di rilevazione impostato è di n. " + frequenzaRilevazioni + " secondi.");
	
		class TimedRunnable implements Runnable {
			
			JSONArray json;

			TimedRunnable( JSONArray j ) {
				json = j;
				System.out.println( "Thread generato.");
			}
	
			public void run() {
				System.out.println( "Avvio del loop dei sensori." );
		        // TODO
				for( int i = 0; i< json.length(); i ++ ) {
				
					JSONObject sensor;
					try {
						sensor = json.getJSONObject(i);
						
						String IDSensore = sensor.getString("IDSensore");
						double Minimo = sensor.getDouble("Minimo");
						double Massimo = sensor.getDouble("Massimo");
						double random =  (Minimo + Math.random() * ( Massimo - Minimo ));	
						String randomString = String.format("%1.2f", random);					
						String output = (IDSensore + "-" + randomString );
						
						System.out.print( "Sensore n. " + i + " : " + IDSensore + " - Range dei valori ammessi:  " + Minimo + " - " + Massimo + ". Valore rilevato: " + randomString );
						
						// Url di destinazione
						
						URL url = null;
						HttpURLConnection con = null;
						
						String target = rootUrl + "/template/user-contents/outputs-receptor.php?rilevazione="+output+"&key="+URLEncoder.encode( key, "UTF-8" );
						url = new URL( target );
						System.out.println( "\n" + url );
						con = (HttpURLConnection) url.openConnection();						
						
						con.setRequestProperty("Content-Type", "text/plain");
						con.setRequestProperty("Content-Language", "it-IT");
						con.setRequestProperty("Accept-Charset", "UTF-8");
						con.setRequestMethod("GET");
						con.setUseCaches(false);
						con.setDoOutput(true);

						DataOutputStream out = null;					
						
						out = new DataOutputStream(con.getOutputStream());
						out.writeBytes(output);
						
						BufferedReader lastBuffer = new BufferedReader(new InputStreamReader(con.getInputStream()));
						String responseLast = lastBuffer.readLine();
						lastBuffer.close();
						
						
						out.flush();
						
						out.close();
						System.out.println("Risposta del server: " + con.getResponseCode() + " - " + con.getResponseMessage() + ". " + responseLast);
						
					} catch (JSONException | IOException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
						System.exit(0);
					}
				
				}	// for
			
			} // run
		} // TimedRunnable
		Thread t = new Thread ( new TimedRunnable ( json ) );
		
	    ScheduledExecutorService service = Executors.newSingleThreadScheduledExecutor();
	    service.scheduleAtFixedRate(t, 0, frequenzaRilevazioni, TimeUnit.SECONDS);		
	}
}
