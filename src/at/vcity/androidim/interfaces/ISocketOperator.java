package at.vcity.androidim.interfaces;


public interface ISocketOperator {
	
	public String sendHttpRequest(String params);
	public int startListening(int port);
	public void stopListening();
	public void exit();
	public int getListeningPort();

}
